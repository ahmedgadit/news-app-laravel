import { Box, ChakraComponent, Image as ChakraImage } from '@chakra-ui/react'
import * as React from 'react'
import { ComponentProps } from 'react'

interface ImageProps extends ComponentProps<ChakraComponent<'div', {}>> {}

export const Image = (props: ImageProps) => {
  const { src, alt, ...rest } = props
  return (
    <Box overflow={"hidden"} position="relative" {...rest}>
      <ChakraImage objectFit="cover" layout="fill" src={src} alt={alt} />
    </Box>
  );
}
